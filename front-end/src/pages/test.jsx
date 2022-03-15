import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";

export default function Test() {
    let params = useParams();

    // TODO: extract back-and-forth method to another file
    const [ currentQuestionIndex, setCurrentQuestionIndex ] = useState( 0 );
    const [ currentApproach, setCurrentApproach ] = useState( 'q2a' );

    const [ currentQuestion, setCurrentQuestion ] = useState();
    const [ expectedAnswer, setExpectedAnswer ] = useState();

    useEffect( () => {
        // TODO: fetch questions / answers
        // TODO: shuffle questions
    } );

    let data = { // will be got from the API
        testType: 'back-and-forth',
        questions: [
            {
                q: 'abrir',
                a: 'to open',
            },
            {
                q: 'acabar',
                a: 'to finish',
            },
            {
                q: 'aceitar',
                a: 'to accept',
            },
        ],
    };

    function getNextQuestion() {
        // TODO: implement loop through questions

        // TODO: when currentApproach's loop is over, swith to another approach and re-shuffle again
    }

    function submitQuestion() {
        // TODO: filter enter presses
    }

    return (
        <>
            <h1>Test #{ params.testID }</h1>
            {/* TODO: address the current question index */}
            Q ( i / N ): <span>{/* TODO: add current question */}</span>
            <input type="text" defaultValue="" onKeyDown={ submitQuestion }/>
        </>
    );
}