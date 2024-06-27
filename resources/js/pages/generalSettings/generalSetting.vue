<script setup>
import { ref } from 'vue';
import { onMounted } from '@vue/runtime-core';
import axios from 'axios';
import { toast } from 'vue3-toastify';
import generalSettingAdd from'./generalSettingAdd.vue';

const generalSettings = ref([]);
const isEdit = ref(false);
const generalSetting = ref({});
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
const addgeneralSetting = ()=>{
    isEdit.value = true;
    generalSetting.value = false;
}
const generalSettingEdit = (generalSettingSelect)=>{
    isEdit.value = true;
    generalSetting.value = generalSettingSelect;
}
const getgeneralSettings = ()=>{
    axios.get(`api/get-general-settings`).then((res)=>{
        generalSettings.value = res.data.generalSettings;
        notify(res.data.message);
    }).catch((err)=>{
        notifyError(err.response.data.message);
    })
}
const goBack = (event)=>{
    isEdit.value = event;
    generalSetting.value = false;
    getgeneralSettings()
}
onMounted(()=>{
    getgeneralSettings();
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
        <generalSettingAdd v-if="isEdit" :generalSetting="generalSetting" @goBack="goBack($event)"/>
        <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-header">
                <h4 class="card-title">generalSettings table</h4>
                <button v-if="checkPermission('generalSettings','create')" class="btn btn-primary btn-circle bts-sm float-end" @click="addgeneralSetting">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td v-if="checkPermission('generalSettings','edit') || checkPermission('generalSettings','delete')">Actions</td>
                                <td>id</td>
                                <td>name</td>
                                <td>logo</td>
                                <td>font</td>
                            </tr>
                        </thead>
                        <tfoot>

                        </tfoot>
                        <tbody>
                            <tr v-for="generalSetting in generalSettings" :key="generalSetting.id">
                                <td v-if="checkPermission('generalSettings','edit') || checkPermission('generalSettings','delete')">
                                    <button v-if="checkPermission('generalSettings','delete')" class="btn btn-danger btn-circle bts-sm m-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button v-if="checkPermission('generalSettings','edit')" @click="generalSettingEdit(generalSetting)" class="btn btn-info btn-circle bts-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td>
                                    {{generalSetting.id}}
                                </td>
                                <td>
                                    {{ generalSetting.name }}
                                </td>
                                <td>
                                    {{ generalSetting.logo }}
                                </td>
                                <td>
                                    {{ generalSetting.font.name_font }} <br>
                                    {{ generalSetting.font_size }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
