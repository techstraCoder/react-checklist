import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axiosBaseurl from "../../../../axiosBaseurl";

export const fetchUsers = createAsyncThunk('fetchUser', async () => {
    const response = await axiosBaseurl.get('/Users/getTeamMembers_post');
    return response.data;
});

const userSlice = createSlice({
    name: "users",
    initialState: {
        users: [],
        loading: false,
        error: null
    },

    reducers: {},

    extraReducers: (builder) => {
        builder
            .addCase(fetchUsers.pending, (state) => {
                state.loading = true;
            })
            .addCase(fetchUsers.fulfilled, (state, action) => {
                state.loading = false;
                state.users = action.payload;
            })
            .addCase(fetchUsers.rejected, (state, action) => {
                state.error = action.error.message;
            })
    }
})

export const userReducer = userSlice.reducer;