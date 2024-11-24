import { Outlet } from "react-router-dom";

const RootLayout = () => {
    return (
        <div className="flex flex-col ">
            <main className="">
                <Outlet />
            </main>
        </div>
    );
};

export default RootLayout;
