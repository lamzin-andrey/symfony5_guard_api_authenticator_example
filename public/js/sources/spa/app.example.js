window.jQuery = window.$ = window.jquery = require('jquery');
window.Vue = require('vue');
Vue.component('bot-scheme-editor', require('./views/botSchemeEditor.vue').default);


// Конфигурация

//Конфигурация каталога с изображениями, которые использует приложение
Vue.prototype.$config = {};
Vue.prototype.$config.imageCatalog = './images/bot-scheme-toolbar';

//Конфигурация расположения коннекторов на блоках различного типа
//см. константы в определении класса BotSchemeEditorBaseComponent
//import BotSchemeEditorBaseComponent from './classes/retecomponents/botschemeeditorbasecomponent';
//Тут хотелось красиво, но к сожалению невозможно импортировать BotSchemeEditorBaseComponent 
//Пришлось обойтись строками
Vue.prototype.$config.connectorsLocation = {
	//Блок "Начало"
	//BeginComponent: BotSchemeEditorBaseComponent.SOCKET_POSITION_H_L2R,
	BeginComponent: 'SOCKET_POSITION_H_L2R',

	//Блок "Сообщение"
	MessageComponent: 'SOCKET_POSITION_H_L2R',

	//Блок "Таймер"
	TimerComponent: 'SOCKET_POSITION_V_T2B',

	//Блок "Условие"
	ConditionComponent: 'SOCKET_POSITION_H_L2R',

	//Блок "Действие"
	ActionComponent: 'SOCKET_POSITION_H_L2R'
};

// /Конфигурация




//Интернациализация
import VueI18n  from 'vue-i18n';
import locales  from './vue-i18n-locales';

const i18n = new VueI18n({
	locale: 'ru', // set locale from window.locale if needs
	messages:locales, // set locale messages
});
//end Интернациализация


window.app = new Vue({
	i18n : i18n,
	el: '#app',

   // router,
   /**
	* @property Данные приложения
   */
   data: {
	 
   },
	/*components:{
		'bse': require('./views/botSchemeEditor.vue').default
	},*/
   /**
	* @description Событие, наступающее после связывания el с этой логикой
   */
   mounted() {
		
   },
   computed:{
		
   },
   /**
	* @property methods эти методы можно указывать непосредственно в @ - атрибутах
   */
   methods:{
	
	
	/**
	 * @description Click on button "Edit article" TODO Пример
	 * @param {Event} evt
	*/
   onClick(evt) {
		
	},
	
   }//end methods

}).$mount('#app');
