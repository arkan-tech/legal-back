import "./bootstrap";
import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";
import "./css/style.css";

createInertiaApp({
    resolve: (name) => {
        // const pages = import.meta.glob("./Pages/**/*.tsx", { eager: true });
        const pages = import.meta.glob("./Pages/**/*.tsx", { eager: true, import: 'default' });
        return pages[`./Pages/${name}.tsx`];
    },
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
});
