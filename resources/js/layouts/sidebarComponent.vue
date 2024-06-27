<script setup>
import { ref } from 'vue';
import { onMounted, watchEffect } from '@vue/runtime-core';

const props = defineProps(["toggled"]);
const perUser = ref(JSON.parse(localStorage.getItem('perUser')));
const setting = JSON.parse(localStorage.getItem('setting'));
const pages = ref([]);
onMounted(async ()=>{
    await getPages();
})
const filteredSubPages = (pages,per)=>{
    return pages.filter((page) => {return checkPermission(page.id,per)})
}
const checkPermission = (page_id,per)=>{
    let permission = perUser.value.find(
        permission => permission.page_id === page_id
        && permission[per] === 1
    )
    if(permission){
        return true;
    }else{
        return false;
    }
}
const getPages = async ()=>{
    await axios.get(`api/get-pages`).then((res)=>{
        pages.value = res.data.pages;
    });
}
watchEffect(()=>{
    if (perUser.value === null) {
        window.location.reload();
    }
})

</script>
<template>
    <ul :class="`navbar-nav bg-gradient-primary sidebar sidebar-dark accordion ${props.toggled}`" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-icon rotate-n-15">
                <!-- <i class="fas fa-code"></i> -->
                <img :src="setting.logo ? '/'+setting.logo: '/app-assets/images/test.jpg'" width="50">
            </div>
            <!-- <div class="sidebar-brand-text mx-3">tebiyan <sup>code</sup></div> -->
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Interface
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li v-for="page in pages" :key="page.id" class="nav-item shadow-lg bg-body-tertiary rounded">
            <a v-if="filteredSubPages(page.pages,'read').length > 0 && checkPermission(page.id,'read')" class="nav-link collapsed" href="#" data-toggle="collapse" :data-target="`#collapseTwo${page.id}`" aria-expanded="true" :aria-controls="`#collapseTwo${page.id}`">
                <i :class="page.icon"></i>
                <span>{{page.page}}</span>
            </a>
            <div :id="`#collapseTwo${page.id}`" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">{{page.page}}</h6>
                    <RouterLink v-for="sub in filteredSubPages(page.pages,'read')" :key="sub.id" class="collapse-item" to="sub.path">
                        <i class="sub.icon"></i>
                        <span>{{sub.page}}</span>
                    </RouterLink>
                </div>
            </div>
            <RouterLink v-if="page.path != '#' && checkPermission(page.id,'read')" class="nav-link" :to="page.path">
                <i :class="page.icon"></i>
                <span>{{page.page}}</span>
            </RouterLink>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Charts -->

    </ul>
</template>
