<script setup>
import { ref } from 'vue';
import { onMounted } from '@vue/runtime-core';
import axios from 'axios';
import { toast } from 'vue3-toastify';
import appFontAdd from'./appFontAdd.vue';

const fonts = ref([]);
const isEdit = ref(false);
const font = ref({});
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
const addfont = ()=>{
    isEdit.value = true;
    font.value = false;
}
const fontEdit = (fontSelect)=>{
    isEdit.value = true;
    font.value = fontSelect;
}
const getFonts = ()=>{
    axios.get(`api/get-fonts`).then((res)=>{
        fonts.value = res.data.fonts;
        notify(res.data.message);
    }).catch((err)=>{
        notifyError(err.response.data.message);
    })
}
const goBack = (event)=>{
    isEdit.value = event;
    font.value = false;
    getFonts()
}
onMounted(()=>{
    getFonts();
})
const perUser = ref(JSON.parse(localStorage.getItem('perUser')));
const checkPermission = (page,per)=>{
    let permission = perUser.value.find(
        permission => permission.page.page === page
        && permission[per] === 1
    )
    if(permission){
        return true;
    }else{
        return false;
    }
}
</script>
<template>
    <div>
        <appFontAdd v-if="isEdit" :font="font" @goBack="goBack($event)"/>
        <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-header">
                <h4 class="card-title">fonts table</h4>
                <button v-if="checkPermission('fonts','create')" class="btn btn-primary btn-circle bts-sm float-end" @click="addfont">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td v-if="checkPermission('fonts','edit') || checkPermission('fonts','delete')">Actions</td>
                                <td>id</td>
                                <td>name</td>
                            </tr>
                        </thead>
                        <tfoot>

                        </tfoot>
                        <tbody>
                            <tr v-for="font in fonts" :key="font.id">
                                <td v-if="checkPermission('fonts','edit') || checkPermission('fonts','delete')">
                                    <button v-if="checkPermission('fonts','delete')" class="btn btn-danger btn-circle bts-sm m-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button v-if="checkPermission('fonts','edit')" @click="fontEdit(font)" class="btn btn-info btn-circle bts-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td>
                                    {{font.id}}
                                </td>
                                <td>
                                    {{font.name_font}}
                                    <br>
                                    {{font.path}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
