const SortedByFilter = ({ setSortedBy }) => {
    const handleSortedByFilter = (e) => {
      setSortedBy(e.target.value);
    };
  
    return (
      <div className=" gap-3 my-5">
        <h3 className="text-gray-600 inline font-bold">Sorted by : </h3>
        <select
        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-2 py-3 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"     
        onChange={handleSortedByFilter}
          name="sortBy"
          id="sortBy"
        >
          <option value="name">Name</option>
          <option value="price">price</option>
        </select>
      </div>
    );
  };
  
  export default SortedByFilter;