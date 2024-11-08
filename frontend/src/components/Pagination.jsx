const Pagination = ({ metadata, setPage }) => {
  const { links, current_page } = metadata;

  const goToPage = (link, i) => {
    let newPage = 0;
    if (i === 0) {
      newPage = current_page - 1;
    } else if (i === links.length - 1) {
      newPage = current_page + 1;
    } else newPage = link.label;

    setPage(newPage);
  };

  return (
    <ul className="flex flex-row gap-4 items-center justify-center my-6">
      {links.map((link, i) => (
        <li key={link.label}>
          <button
            onClick={() => goToPage(link, i)}
            className={`border-2 rounded-lg p-3 transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg ${
              link.active
                ? "bg-blue-600 text-white border-blue-700"
                : !link.url
                ? "hidden"
                : "bg-gray-300 text-gray-800 border-gray-400 hover:bg-blue-500 hover:text-white"
            }`}
          >
            {i === 0 ? (
              "<<"
            ) : i === links.length - 1 ? (
              ">>"
            ) : (
              link.label
            )}
          </button>
        </li>
      ))}
    </ul>
  );
};

export default Pagination;
