import { createRouter,createWebHistory } from "vue-router";
import { isUserLoggedIn } from "./utils";

const router = createRouter({
    history:createWebHistory(),
    routes:[
        {
            path:'/home',
            name:'home',
            component:()=> import('../layouts/home.vue'),
        },
        {
            path:'/admin',
            name:'admin',
            component:()=> import('../pages/admin.vue'),
        },
        {
            path:'/users',
            name:'users',
            component:()=> import('../pages/users/user.vue'),
        },
        {
            path:'/pages',
            name:'pages',
            component:()=> import('../pages/pages/page.vue'),
        },
        {
            path:'/permissions',
            name:'permissions',
            component:()=> import('../pages/permissions/permissions.vue'),
        },
        {
            path:'/roles',
            name:'roles',
            component:()=> import('../pages/roles/role.vue'),
        },
        {
            path:'/translates',
            name:'translates',
            component:()=> import('../pages/translates/translate.vue'),
        },
        {
            path:'/register',
            name:'register',
            component:()=> import('../pages/register.vue'),
        },
        {
            path:'/forgotpassword',
            name:'forgotpassword',
            component:()=> import('../pages/forgotpassword.vue'),
        },
        {
            path:'/reset-password-form',
            name:'resetpasswordform',
            component:()=> import('../pages/resetpasswordform.vue'),
        },
        {
            path:'/reset-password-form-sent',
            name:'resetpasswordformsent',
            component:()=> import('../pages/resetpasswordformsent.vue'),
        },
        {
            path:'/login',
            name:'login',
            component:()=> import('../pages/login.vue'),
        },
        {
            path:'/profile',
            name:'profile',
            component:()=> import('../pages/profile.vue'),
        },
        {
            path:'/:pathMatch(.*)*',
            component:()=> import('../pages/notfound.vue'),
        }
    ]
})

router.beforeEach((to,from,next)=>{
    if ((to.name === 'register' || to.name === 'forgotpassword' || to.name === 'resetpasswordform') && !isUserLoggedIn()) {
        next()
    } else if(to.name !== 'login' && !isUserLoggedIn()) {
        next({name:'login'})
    } else if((to.name === 'login' || to.name === 'register') && isUserLoggedIn()) {
        next({name:'admin'})
    }
    else{
        next()
    }
});
export default router;