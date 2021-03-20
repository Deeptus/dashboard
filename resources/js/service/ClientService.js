import axios from 'axios'

export default class ClientService {

	getClients() {
		return axios.get('/adm/api/clients').then(res => res.data.data);
	}

	getClient(id) {
		return axios.get('/adm/api/client/'+id).then(res => res.data.data);
	}


}