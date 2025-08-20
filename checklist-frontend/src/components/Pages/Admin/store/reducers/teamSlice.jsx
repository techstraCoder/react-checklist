import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axiosBaseurl from "../../../../axiosBaseurl";

export const fetchTeams = createAsyncThunk('fetchTeams', async () => {
    const response = await axiosBaseurl.get('/Users/getTeams');
    return response.data.teams;
});

const teamSlice = createSlice({
    name: "teams",
    initialState: {
        teams: [],
        loading: false,
        error: null
    },

    reducers: {},

    extraReducers: (builder) => {
        builder
            .addCase(fetchTeams.pending, (state) => {
                state.loading = true;
            })
            .addCase(fetchTeams.fulfilled, (state, action) => {
                state.loading = false;
                state.teams = action.payload;
            })
            .addCase(fetchTeams.rejected, (state, action) => {
                state.error = action.error.message;
            })
    }
})

export const teamsReducer = teamSlice.reducer;