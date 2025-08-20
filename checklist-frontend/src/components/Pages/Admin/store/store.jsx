import { configureStore } from '@reduxjs/toolkit'
import { userReducer } from './reducers/userSlice'
import { teamsReducer } from './reducers/teamSlice'
import { boardsReducer } from './reducers/boardSlice'


export const store = configureStore({
    reducer: {
        users: userReducer,
        teams: teamsReducer,
        boards: boardsReducer
    },
})