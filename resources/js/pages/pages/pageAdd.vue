<script setup>
import { ref } from '@vue/reactivity';
import { toast } from 'vue3-toastify';
import { watchEffect } from '@vue/runtime-core';

const emit = defineEmits(['goBack']);
const props = defineProps(['page','pages']);
const notify = (message)=>{
    toast.success(message,{
        autoClose:3000,
        position:toast.POSITION.TOP_CENTER
    });
}
const notifyError = (message)=>{
    toast.error(message,{
        autoClose:3000,
        position:toast.POSITION.TOP_CENTER
    });
}
const id = ref("");
const page = ref("");
const item = ref({});
const pages = ref([]);

const createPage =()=>{ 
    if ( item.value ==='') {
        alert('Please fill all fields')
    }    
    else {
        axios.post('api/create-page',item.value).then((res)=>{
        	notify(res.data.message);
        	emit('goBack',false);
            item.value = {}
        }).catch((err)=>{
        	notifyError(err.response.data.message);
        })
    }
}
const goBack = ()=>{
    page.value = ''
    emit('goBack',false);
}
watchEffect(()=>{
    if (props.page) {
        item.value = props.page
    }else{
        item.value = {
            page:'',
            path:'#',
            icon:'fa fa-file-text-o',
            page_id:0,
            order:0
        }
    }
    if (props.pages) {
        pages.value = props.pages;
        pages.value.push({id:0,page:'no page'});
    }
})
</script>
<template>
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">
                                 {{props.page ? 'Update an Account!' : 'Create an Account!'}} 
                                </h1>
                            </div>
                            <form class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="item.page" class="form-control form-control-user"
                                            placeholder="Page">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="item.path" class="form-control form-control-user"
                                            placeholder="Path">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="item.icon" class="form-control form-control-user"
                                            placeholder="Icon">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <select class="form-control" v-model="item.page_id">
                                            <option v-for="page in pages" :key="page.id" :value="page.id">{{page.page}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" v-model="item.order" class="form-control form-control-user"
                                            placeholder="Order">
                                    </div>
                                </div>
                                
                                <a @click="createPage()" class="btn btn-primary btn-user btn-block">
                                    {{props.page ? 'update' : 'create Page'}} 
                                </a>
                                <a @click="goBack()" class="btn btn-info btn-user btn-block">
                                    Back
                                </a>                                
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>