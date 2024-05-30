<script setup>
import { ref } from '@vue/reactivity';
import { toast } from 'vue3-toastify';
import { watchEffect } from '@vue/runtime-core';

const emit = defineEmits(['goBack']);
const props = defineProps(['font']);
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
const font = ref("");
const item = ref({});

const createFont =()=>{
    if ( item.value.name_font ==='') {
        alert('Please fill all fields')
    }
    else {
    console.log(item);
        axios.post('api/create-font',item.value,{headers:{"Content-Type":"multipart/form-data"}}).then((res)=>{
        	notify(res.data.message);
        	emit('goBack',false);
            item.value = {}
        }).catch((err)=>{
        	notifyError(err.response.data.message);
        })
    }
}
const goBack = ()=>{
    font.value = ''
    emit('goBack',false);
}
const uploadFile = (e)=>{
    let file = e.target.files[0];
    if (file.size > 8388608) {
        alert('file is to big! > 8MB');
        return false;
    }
    item.value.file_font = file;
}
watchEffect(()=>{
    if (props.font) {
        item.value = props.font
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
                                 {{props.font ? 'Update an Font!' : 'Create an Font!'}}
                                </h1>
                            </div>
                            <form class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="item.name_font" class="form-control form-control-user"
                                            placeholder="Font">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="file" ref="file" @change="uploadFile" class="form-control form-control-user"
                                            placeholder="Path">
                                        <label v-if="props.font">{{ item.path }}</label>
                                    </div>
                                </div>

                                <a @click="createFont()" class="btn btn-primary btn-user btn-block">
                                    {{props.font ? 'update' : 'create Font'}}
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
