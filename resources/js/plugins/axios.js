import axios from 'axios';


axios.defaults.headers.common = {'Authorization': `bearer ${token}`}
export default axios;