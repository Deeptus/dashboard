import Vue from 'vue';
import Router from 'vue-router';
import Dashboard from './components/Dashboard.vue';
import Crud from './components/providers/providers.vue';
import CrudCreate from './components/crud/index.vue';
import CrudGenerator from './components/crud-generator/cruds.vue';
import CrudEdit from './components/crud-generator/index.vue';
import CrudUsers from './components/users/index.vue';
import WebConfig from './components/company-data/CompanyDataFormComponent.vue';

Vue.use(Router);

export default new Router({
	routes: [
		{
			path: '/',
			name: 'dashboard',
			component: Dashboard
		},
		{
			path: '/company-data',
			name: 'webconfig',
			component: WebConfig
		},
		{
			path: '/crud/:table',
			name: 'crud',
			component: Crud,
			props: true
		},
		{
			path: '/crud/:table/create',
			name: 'crudcreate',
			component: CrudCreate,
			props: true
		},
		{
			path: '/crud-generator/',
			name: 'crudgenerator',
			component: CrudGenerator,
			props: true
		},
		{
			path: '/crud-generator/:file',
			name: 'cre',
			component: CrudEdit,
			props: true
		},
		{
			path: '/crud-generator/create',
			name: 'cren',
			component: CrudEdit,

		},
		{
			path: '/crud/:table/:id/edit',
			name: 'ced',
			component: CrudCreate,

		},
		{
			path: '/users',
			name: 'users',
			component: CrudUsers,

		},
	],
	scrollBehavior() {
		return {x: 0, y: 0};
	}
});
