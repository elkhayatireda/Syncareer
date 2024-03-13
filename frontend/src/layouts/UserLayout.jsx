import TopNav from "@/components/user/TopNav";
import { useEffect } from "react";
import { Outlet } from "react-router-dom";

function UserLayout() {
    useEffect(() => {
        document.body.classList.add('bg-bbackground');
        return () => {
            document.body.classList.remove('bg-bbackground');
        }
    })

   

    return (
        <div className="h-screen" >
            <header className="border-b border-gray-500 border-1">
                <TopNav />
            </header>
            <main className=" pb-6 bg-white h-screen">
                <Outlet  />
            </main>
        </div>
    );
}

export default UserLayout;