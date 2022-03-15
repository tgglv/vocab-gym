import { useEffect } from "react";
import { useParams, useNavigate  } from "react-router-dom";

export default function Result() {
    let params = useParams();
    let navigate = useNavigate();

    useEffect( () => {
        // TODO: fetch results for the test
    }, [] );

    return (
        <>
            <h1>Results for test #{ params.testID }</h1>
            <button onClick={ () => navigate( '/' ) }>Continue</button>
        </>
    );
}