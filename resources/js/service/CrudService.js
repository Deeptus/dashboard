import axios from 'axios'

export default class CrudService {

	getMenu() {
		return axios.get('/adm/api/menu').then(res => res.data);
	}



	getTable(name) {
		return axios.get('/adm/crud/'+name).then(res => res.data);
	}


	getData(name) {
		return axios.get('/adm/crud/api/'+name+'/data').then(res => res.data);
	}



}