import axios from 'axios'

export default class UserService {

	getUsers() {
		return axios.get('/adm/api/users').then(res => res.data.data);
	}

	getUser(id) {
		return axios.get('/adm/api/user/'+id).then(res => res.data.data);
	}


}