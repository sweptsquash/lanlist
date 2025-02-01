import axios, { Axios } from 'axios'

export default (): Axios => {
  return axios.create({
    withCredentials: true,
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
  })
}
