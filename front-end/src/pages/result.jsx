import { useEffect, useState } from "react";
import { useParams, useNavigate  } from "react-router-dom";

export default function Result() {
    const [ result, setResult ] = useState();

    let params = useParams();
    let navigate = useNavigate();

    // Fetch attempt's result
    useEffect( () => {
        fetch( `http://vocab.gym:9090/attempts/${ params.attemptID }/result` )
            .then( res => res.json() )
            .then( res => { 
                setResult( res );
            } );
    }, [] );

    function showResult() {
        return (
            <>
                <div key="topic" className="topic">Topic: <span>{ result.topic.name }</span></div>

                <table>
                { result.answers.map( ( answer, key ) => {
                    return (                        
                        <tr key={ `answer-${key}`} className={ `answer answer_${answer.status}` }>
                            <td className="question">Question:</td>
                            <td>{ answer.q }</td>
                            <td className="answer">Correct answer:</td>
                            <td>{ answer.a }</td>
                            <td className="user-answered">Your answer:</td>
                            <td>{ answer.q2a }</td>
                            <td>|</td>
                            <td>{answer.a2q}</td>
                        </tr>
                    );
                } ) }
                </table>
            </>
        );
    }

    return (
        <>
            <h1>Results for test #{ params.testID }</h1>
            { result && showResult() }
            <button onClick={ () => navigate( '/' ) }>Continue</button>
        </>
    );
}