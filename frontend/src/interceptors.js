import httpClient from "./httpClient";
import store from "./store";

export default function setup() {
  httpClient.interceptors.request.use(
    function(config) {
      const token = store.getters.token;
      if (token) {
        config.headers.Authorization = `Bearer ${token}`;
      }
      return config;
    },
    function(err) {
      return Promise.reject(err);
    }
  );
}
