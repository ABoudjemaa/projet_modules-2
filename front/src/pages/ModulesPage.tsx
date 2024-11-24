import { Card } from "@/components/ui/card";
import { useEffect, useState } from "react";
import { Link, useNavigate } from "react-router-dom";


const ModulesPage = () => {
  const navigate = useNavigate();
  const [modules, setModules] = useState<{ id: number; title: string }[]>([]);
  const token = localStorage.getItem("authToken");

  useEffect(() => {
    if (!token) {
      navigate("/modules");
    } else {
      fetch(`http://127.0.0.1:8000/api/modules`, {
        headers: { "Authorization": `Bearer ${localStorage.getItem("authToken")}` },
      })
        .then((response) => response.json())
        .then((data) => setModules(data))
        .catch((error) => console.error(error));
    }

  }, []);

  if (!token) {
    <h1 className="text-xl text-red-600">you are not logged in</h1>
  }

  return (
    <div className="p-4">
      <h1 className="text-xl font-bold mb-4">Modules</h1>
      <ul className="">
        {modules && modules.map((module, index) => (
          <li key={module.id}>
            <Card key={index} className="p-4 bg-white ">
              <Link
                to={`/modules/${module.id}`}
                className="hover:underline"
              >
                <h2>{module.title}</h2>
              </Link>
            </Card>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default ModulesPage;
