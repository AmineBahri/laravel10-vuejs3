<script setup>
import { ref } from 'vue';
import { onMounted } from '@vue/runtime-core';
import axios from 'axios';
import { toast } from 'vue3-toastify';
import pageAdd from'./pageAdd.vue';

const pages = ref([]);
const isEdit = ref(false);
const page = ref({});
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
const addpage = ()=>{
    isEdit.value = true;
    page.value = false;
}
const pageEdit = (pageSelect)=>{
    isEdit.value = true;
    page.value = pageSelect;
}
const getPages = ()=>{
    axios.get(`api/get-pages`).then((res)=>{
        pages.value = res.data.pages;
        notify(res.data.message);
    }).catch((err)=>{
        notifyError(err.response.data.message);
    })
}
const goBack = (event)=>{
    isEdit.value = event;
    page.value = false;
    getPages()
}
onMounted(()=>{
    getPages();
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
        <pageAdd v-if="isEdit" :page="page" @goBack="goBack($event)" :pages="pages"/>
        <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-header">
                <h4 class="card-title">pages table</h4>
                <button v-if="checkPermission('pages','create')" class="btn btn-primary btn-circle bts-sm float-end" @click="addpage">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td v-if="checkPermission('pages','edit') || checkPermission('pages','delete')">Actions</td>
                                <td>id</td>
                                <td>name</td>
                            </tr>   
                        </thead>
                        <tfoot>

                        </tfoot>
                        <tbody>
                            <tr v-for="page in pages" :key="page.id">
                                <td v-if="checkPermission('pages','edit') || checkPermission('pages','delete')">
                                    <button v-if="checkPermission('pages','delete')" class="btn btn-danger btn-circle bts-sm m-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button v-if="checkPermission('pages','edit')" @click="pageEdit(page)" class="btn btn-info btn-circle bts-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td>
                                    {{page.id}}
                                </td>
                                <td>
                                    {{page.page}}
                                </td>
                            </tr>                                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>