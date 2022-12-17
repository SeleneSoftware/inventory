// This isn't implemented yet.  Just waiting for a time when I need it.

import * as React from "react";
import { List, Datagrid, TextField, EmailField } from 'react-admin';

const UserList = () => (
    <List>
        <Datagrid rowClick="edit">
            <TextField source="id" />
            <EmailField source="email" />
        </Datagrid>
    </List>
);

export default UserList;
