import axios from "axios";

const baseUrl = process.env.REACT_APP_BASE_URL;
console.log(baseUrl);
async function fetchProducts(categoryId, sort_by, page) {
  const response = await axios.get(
    `${baseUrl}/products?category_id=${categoryId}&sort_by=${sort_by}&page=${page}`
  );
  return response.data;
}

async function fetchCategories() {
  const response = await axios.get(`${baseUrl}/categories`);
  return response.data;
}

export { fetchProducts, fetchCategories };