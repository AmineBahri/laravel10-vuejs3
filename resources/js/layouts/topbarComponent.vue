<script setup>
import { ref } from 'vue';

const toggled = ref("");
const emit = defineEmits(['emitToggled']);
const props = defineProps(["user"]);
const lang = localStorage.getItem("lang");
const sidebarToggleTop =()=>{
    if (toggled.value === "") {
        toggled.value = "toggled"
        emit('emitToggled',toggled.value)
    } else{
        toggled.value = ""
        emit('emitToggled',toggled.value)
    }
}
const logout =()=>{
    axios.get('api/logout').then((res)=>{
        localStorage.removeItem('token');
        localStorage.removeItem('perUser');
        window.location.href = '/login';
    }).catch((err)=>{
        console.log(err);
    })
    localStorage.removeItem('token');
    window.location.href = '/login';
}
const changeLanguage = (lang)=>{
    localStorage.setItem('lang',lang);
    if(lang=="ar"){
        localStorage.setItem('direction','rtl');
    }else{
        localStorage.setItem('direction','ltr');
    }
    window.location.reload();
}
</script>
<template>
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" @click="sidebarToggleTop">
            <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Search -->
        <form
            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                    aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                    aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Search for..." aria-label="Search"
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter">1+</span>
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Alerts Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 12, 2019</div>
                            <span class="font-weight-bold">A new monthly report is ready to download!</span>
                        </div>
                    </a>

                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                </div>
            </li>

            <!-- Nav Item - Langs -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="langsDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-language fa-fw"></i>
                    <!-- Counter - Langs -->
                    <span class="badge badge-danger badge-counter">{{lang}}</span>
                </a>
                <!-- Dropdown - Langs -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="langsDropdown">
                    <h6 class="dropdown-header">
                        Langs
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" @click="changeLanguage('en')">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <h4>en</h4>
                            </div>
                        </div>
                        <div>
                            <span class="font-weight-bold">{{$t('english')}}</span>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" @click="changeLanguage('fr')">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <h4>fr</h4>
                            </div>
                        </div>
                        <div>
                            <span class="font-weight-bold">{{$t('french')}}</span>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" @click="changeLanguage('ar')">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <h4>ar</h4>
                            </div>
                        </div>
                        <div>
                            <span class="font-weight-bold">{{$t('arabic')}}</span>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" @click="changeLanguage('tr')">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <h4>tr</h4>
                            </div>
                        </div>
                        <div>
                            <span class="font-weight-bold">{{$t('turkish')}}</span>
                        </div>
                    </a>
                </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-envelope fa-fw"></i>
                    <!-- Counter - Messages -->
                    <span class="badge badge-danger badge-counter">1</span>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">
                        Message Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" :src="'../images/user/'+props.user.photo"
                                alt="...">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                problem I've been having.</div>
                            <div class="small text-gray-500">Emily Fowler · 58m</div>
                        </div>
                    </a>

                    <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{props.user.name}}</span>
                    <img class="img-profile rounded-circle"
                        :src="'../images/user/'+props.user.photo">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    <router-link class="dropdown-item" to="/profile">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </router-link>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" @click="logout()" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>

    </nav>
</template>
<script>
export default {
  data() {
    return {
      imageUrlOne: 'img/undraw_profile.svg',
      imageUrlTwo: 'img/undraw_profile_1.svg'
    };
  }
};
</script>