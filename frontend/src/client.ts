import axios from 'axios'

const baseURL = process.env.VUE_APP_API_URL

const client = axios.create({
  baseURL,
  headers: {
    'Content-Type': 'application/json'
  },
  data: {},
  responseType: 'json'
})

export default client
