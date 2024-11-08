import { useState } from "react";
import useCreateProduct from "../services/useCreateProduct";

const CreateProduct =({ refetchProducts })  => {
  const [toggleForm, setToggleForm] = useState(false);
  const [formData, setFormData] = useState({
    name: "",
    description: "",
    price: "",
    category: "",
    image: null,
  });

  const createProduct = useCreateProduct();

  const handleChange = (e) => {
    const { name, value, files } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: files ? files[0] : value,
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    const data = new FormData();
    data.append("name", formData.name);
    data.append("description", formData.description);
    data.append("price", formData.price);
    data.append("category", formData.category);
    if (formData.image) {
      data.append("image", formData.image);
    }
    createProduct.mutate(data, {
      onSuccess: () => {
        // Rafraîchir les produits après l'ajout réussi
        refetchProducts();
        // Réinitialiser le formulaire
        setFormData({
          name: "",
          description: "",
          price: "",
          category: "",
          image: null,
        });
        // Fermer la modal
        setToggleForm(false);
      },
    });
  };

  return (
    <div>
      <button
        className="bg-blue-800 text-white p-3 mb-4 ml-auto rounded-md"
        onClick={() => setToggleForm(true)}
      >
        + Create Product
      </button>

      {toggleForm && (
        <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
          <div className="bg-white p-10 rounded-md text-sm font-medium text-gray-900 w-full max-w-md">
            <h2 className="text-lg font-bold mb-4">Create New Product</h2>
            <form onSubmit={handleSubmit}>
              <div className="mb-5">
                <label htmlFor="name" className="block mb-2 ">
                  Name :
                </label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  required
                  value={formData.name}
                  onChange={handleChange}
                />
              </div>
              <div className="mb-5">
                <label htmlFor="description" className="block mb-2 ">
                  Description :
                </label>
                <textarea
                  id="description"
                  className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  required
                  name="description"
                  value={formData.description}
                  onChange={handleChange}
                ></textarea>
              </div>
              <div className="mb-5">
                <label htmlFor="price" className="block mb-2 ">
                  Price :
                </label>
                <input
                  type="number"
                  step={0.01}
                  id="price"
                  name="price"
                  className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  required
                  value={formData.price}
                  onChange={handleChange}
                />
              </div>
              <div className="mb-5">
                <label htmlFor="image" className="block mb-2 ">
                  Image :
                </label>
                <input
                  type="file"
                  id="image"
                  name="image"
                  className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                  required
                  onChange={handleChange}
                />
              </div>
              <div className="flex justify-end gap-2">
                <button
                  type="button"
                  className="bg-gray-500 py-2 px-4 rounded-md text-white font-bold"
                  onClick={() => setToggleForm(false)}
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  className="bg-green-500 py-2 px-4 rounded-md text-white font-bold"
                >
                  Submit
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};

export default CreateProduct;
