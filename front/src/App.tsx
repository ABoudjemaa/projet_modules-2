import LoginPage from "./pages/LoginPage";
import ModulesPage from "./pages/ModulesPage";
import RootLayout from "./Layouts/RootLayout";
import ModuleDetailsPage from "./pages/ModuleDetailsPage";
import { Routes, Route } from "react-router-dom";

const App = () => {
  return (
    <Routes>
      <Route path="/" element={<RootLayout />}>
        <Route index element={<LoginPage />} />
        <Route path="modules" element={<ModulesPage />} />
        <Route path="modules/:id" element={<ModuleDetailsPage />} />
      </Route>
    </Routes>
  );
};

export default App;
