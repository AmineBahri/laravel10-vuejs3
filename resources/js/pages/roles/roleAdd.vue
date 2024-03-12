<script setup>
import { ref } from '@vue/reactivity';
import { toast } from 'vue3-toastify';
import { watchEffect } from '@vue/runtime-core';

const emit = defineEmits(['goBack']);
const props = defineProps(['role']);
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
const role = ref("");
const item = ref({});

const createRole =()=>{ 
    if ( item.value ==='') {
        alert('Please fill all fields')
    }    
    else {
        axios.post('api/create-role',item.value).then((res)=>{
        	notify(res.data.message);
        	emit('goBack',false);
            item.value = {}
        }).catch((err)=>{
        	notifyError(err.response.data.message);
        })
    }
}
const goBack = ()=>{
    role.value = ''
    emit('goBack',false);
}
watchEffect(()=>{
    if (props.role) {
        item.value = props.role
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
                                 {{props.role ? 'Update an Account!' : 'Create an Account!'}} 
                                </h1>
                            </div>
                            <form class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="item.name_role" class="form-control form-control-user"
                                            placeholder="Role">
                                    </div>
                                   
                                </div>
                                
                                <a @click="createRole()" class="btn btn-primary btn-user btn-block">
                                    {{props.role ? 'update' : 'create Role'}} 
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