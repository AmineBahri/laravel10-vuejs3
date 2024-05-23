<script setup>
import { ref } from 'vue';
import sidebarComponent from '../layouts/sidebarComponent.vue';
import topbarComponent from '../layouts/topbarComponent.vue';
import footerComponent from '../layouts/footerComponent.vue';

const toggled = ref("");
const token = localStorage.getItem('token');
const dir  = localStorage.getItem('direction');
const user = ref("");
axios.get('api/user').then((res)=>{
    user.value = res.data.user;
    localStorage.setItem('perUser',JSON.stringify(res.data.user.role.permissions));
});
</script>
<template>
    <div id="wrapper">

        <!-- Sidebar -->
        <sidebarComponent v-if="token" :toggled="toggled"></sidebarComponent>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <topbarComponent v-if="token" @emitToggled="toggled=$event" :user="user"></topbarComponent>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <v-locale-provider :rtl="dir=='rtl'">
                        <router-view :user="user"></router-view>
                    </v-locale-provider>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footerComponent v-if="token"></footerComponent>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
</template>
