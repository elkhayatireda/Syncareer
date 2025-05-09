import React from "react";
import ReactDOM from "react-dom/client";

import "./assets/index.css";

import {
    RouterProvider,
} from 'react-router-dom';
import { router } from './router';

// import { Toaster } from 'sonner'
import { AuthWrapper } from "./contexts/AuthWrapper";

ReactDOM.createRoot(document.getElementById("root")).render(
    <React.StrictMode>
        <AuthWrapper>
            {/* <Toaster position="bottom-right" richColors /> */}
            <RouterProvider router={router} />
        </AuthWrapper>
    </React.StrictMode>
);
