import axios from "axios";

export const customAxios = axios.create({
  baseURL: "http://localhost:80/api",
});
