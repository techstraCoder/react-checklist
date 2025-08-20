import React, { useState } from 'react'
import './DropArea.css'
export const DropArea = ({onDrop}) => {
  const [dropActive,setdropActive] = useState(false);
  return (
    <div className={dropActive ? "mb-2 card-container bg-secondary bg-gradient shadow p-3 mb-5 bg-secondary bg-gradient rounded drop_area" : "hide_area"}
    onDragEnter={()=>setdropActive(true)}
    onDragLeave={()=>{setdropActive(false)}} 
    onDrop={()=>{
      onDrop()
      setdropActive(false)
    }}
    onDragOver={e=>e.preventDefault()}
    >
    </div>
  )
}
