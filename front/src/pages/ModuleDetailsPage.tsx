import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";

const ModuleDetailsPage = () => {
    const { id } = useParams<{ id: string }>();
    const [module, setModule] = useState<{
        id: number;
        title: string;
        description: string;
        createdAt: string;
    } | null>(null);

    useEffect(() => {
        fetch(`http://127.0.0.1:8000/api/modules/${id}`, {
            headers: { Authorization: `Bearer ${localStorage.getItem("authToken")}` },
        })
            .then((response) => response.json())
            .then((data) => setModule(data))
            .catch((error) => console.error(error));
    }, [id]);

    if (!module) {
        return <div>Loading...</div>;
    }

    return (
        <div className="p-4">
            <h1 className="text-2xl font-bold mb-4">title : {module.title}</h1>
            <p className="text-lg mb-4">Description : {module.description}</p>
            <p className="text-gray-500">Created At: {module.createdAt}</p>
        </div>
    );
};

export default ModuleDetailsPage;
