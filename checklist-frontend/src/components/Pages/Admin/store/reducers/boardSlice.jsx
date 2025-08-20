import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axiosBaseurl from "../../../../axiosBaseurl";

export const fetchBoards = createAsyncThunk('fetchBoards', async () => {
    const response = await axiosBaseurl.get('/Users/boarddetails');
    return response.data;
});

const boardsSlice = createSlice({
    name: "boards",
    initialState: {
        boards: [],
        loading: false,
        error: null
    },

    reducers: {},

    extraReducers: (builder) => {
        builder
            .addCase(fetchBoards.pending, (state) => {
                state.loading = true;
            })
            .addCase(fetchBoards.fulfilled, (state, action) => {
                state.loading = false;
                state.boards = action.payload;
            })
            .addCase(fetchBoards.rejected, (state, action) => {
                state.error = action.error.message;
            })
    }
})

export const boardsReducer = boardsSlice.reducer;