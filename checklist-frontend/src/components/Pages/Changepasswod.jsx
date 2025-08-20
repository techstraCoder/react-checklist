import { useLocation } from "react-router-dom";

function Changepassword() {
    const location = useLocation();
    return(
      <div>Chnagepassword {location.state.id}</div>
    );
}

export default Changepassword;