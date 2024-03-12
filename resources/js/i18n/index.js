import axios from 'axios';
import {createI18n} from 'vue-i18n';

axios.get(`api/get-i18n`).then((res)=>{
	localStorage.setItem("messages",JSON.stringify(res.data));
});

const i18n = createI18n({
	locale: localStorage.getItem("lang") ? localStorage.getItem("lang") : 'en',
	messages: JSON.parse(localStorage.getItem("messages")),
})
export default i18n;
