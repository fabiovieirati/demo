import axios from 'axios'

const baseURL = 'http://backend.com.br:5000/api'

export const api = () => {
    return axios.create({
        baseURL
    })
}