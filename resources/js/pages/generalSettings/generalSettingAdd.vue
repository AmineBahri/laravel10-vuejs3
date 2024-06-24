<script setup>
import { ref } from '@vue/reactivity';
import { toast } from 'vue3-toastify';
import { onMounted,watchEffect } from '@vue/runtime-core';

const emit = defineEmits(['goBack']);
const props = defineProps(['generalSetting']);
onMounted(()=>{
    getFonts();
})
const getFonts = ()=>{
    axios.get(`api/get-fonts`).then((res)=>{
        fonts.value = res.data.fonts;
        notify(res.data.message);
    }).catch((err)=>{
        notifyError(err.response.data.message);
    })
}
const fonts = ref([]);
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
const generalSetting = ref("");
const item = ref({});

const creategeneralSetting =()=>{
    if ( item.value.name ==='') {
        alert('Please fill all fields')
    }
    else {
        console.log(item);
        axios.post('api/create-general-setting',item.value,{headers:{"Content-Type":"multipart/form-data"}}).then((res)=>{
        	notify(res.data.message);
        	emit('goBack',false);
            item.value = {}
        }).catch((err)=>{
        	notifyError(err.response.data.message);
        })
    }
}
const goBack = ()=>{
    generalSetting.value = ''
    emit('goBack',false);
}
const uploadFile = (e)=>{
    let file = e.target.files[0];
    if (file.size > 8388608) {
        alert('file is to big! > 8MB');
        return false;
    }
    item.value.file_image = file;
}
watchEffect(()=>{
    if (props.generalSetting) {
        item.value = props.generalSetting
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
                                 {{props.generalSetting ? 'Update an general Setting!' : 'Create an general Setting!'}}
                                </h1>
                            </div>
                            <form class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="item.name" class="form-control form-control-user"
                                            placeholder="name">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="email" v-model="item.email" class="form-control form-control-user"
                                            placeholder="email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="item.facebook" class="form-control form-control-user"
                                            placeholder="facebook">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="item.youtube" class="form-control form-control-user"
                                            placeholder="youtube">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="file" ref="file" @change="uploadFile" class="form-control form-control-user"
                                            placeholder="logo">
                                        <!-- <label v-if="props.generalSetting">{{ item.logo }}</label> -->
                                        <img :src="'/'+item.logo" width="150">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <select class="form-control" v-model="item.font_id">
                                            <option v-for="font in fonts" :key="font.id" :value="font.id">{{font.name_font}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" step="0.1" v-model="item.font_size" class="form-control form-control-user"
                                            placeholder="font_size">
                                    </div>
                                </div>

                                <a @click="creategeneralSetting()" class="btn btn-primary btn-user btn-block">
                                    {{props.generalSetting ? 'update' : 'create general Setting'}}
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
