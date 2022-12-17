import * as React from "react";
import { List, Datagrid, TextField, EmailField } from 'react-admin';

const ProductList = () => (
    <List>
        <Datagrid rowClick="edit">
            <TextField source="name" />
            <TextField source="sku" />
        </Datagrid>
    </List>
);

export default ProductList;
