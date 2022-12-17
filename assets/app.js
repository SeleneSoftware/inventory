/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "./styles/app.scss";

// start the Stimulus application
import "./bootstrap";

// in src/App.js
import * as React from "react";
import { createRoot } from "react-dom/client";
import { Admin, Resource, ListGuesser, EditGuesser } from "react-admin";
import ProductList from './lists/Product.js'
import jsonServerProvider from "ra-data-json-server";

// const dataProvider = jsonServerProvider("https://jsonplaceholder.typicode.com");
const dataProvider = jsonServerProvider("http://inventory.box/api");

const App = () => (
    <Admin dataProvider={dataProvider}>
        <Resource name="products" list={ProductList} edit={EditGuesser} />
        <Resource name="product_types" list={ListGuesser} />
    </Admin>
);
// export default App;

const container = document.getElementById("root");
const root = createRoot(container);
root.render(<App tab="home" />);
