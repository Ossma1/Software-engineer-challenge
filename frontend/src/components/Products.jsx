import { useState } from "react";
import useProducts from "../services/useProducts";
import Pagination from "./Pagination";
import ProductsTable from "./ProductsTable";
import CategoriesFilter from "./CategoriesFilter";
import CreateProduct from "./CreateProduct";
import SortedByFilter from "./SortedByFilter";

const Products = () => {
  const [page, setPage] = useState(0);
  const [categoryId, setCategoryId] = useState("");
  const [sortedBy, setSortedBy] = useState("");

  const { isPending, isError, error, data, isFetching, isPlaceholderData , refetch} =
    useProducts(categoryId, sortedBy, page);
  
  const products = data?.data;

  return (
    <>
    <div className="shadow-lg rounded-xl overflow-hidden mb-4 bg-white flex items-center p-4">
    <div className="flex items-center">
      <span className="text-blue-800 font-semibold text-lg">🧑‍🏫 Gestion des produits</span>
    </div>
  </div>
  
  
  
  
  <div className="relative overflow-x-auto shadow-md sm:rounded-lg">
  <div className="flex justify-between items-end ml-10 mr-10">
      <div className="flex gap-10">
          <CategoriesFilter categoryId={categoryId} setCategoryId={setCategoryId} />
          <SortedByFilter setSortedBy={setSortedBy} />
      </div>
      <div>
      <CreateProduct refetchProducts={refetch} />
      </div>
  </div>
  
  <ProductsTable products={products} isFetching={isFetching} isError={isError} />
  {data ? <Pagination metadata={data.meta} setPage={setPage} /> : ""}
</div>

  </>
  );
};

export default Products;