import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";

export default function Test() {
    let params = useParams();

    const [ mode, setMode ] = useState( 'demo' ); // will be switched to 'test'

    // TODO: extract back-and-forth method to another file
    const [ currentQuestionIndex, setCurrentQuestionIndex ] = useState( 0 );
    const [ currentApproach, setCurrentApproach ] = useState( 'q2a' );

    const [ answer, setAnswer ] = useState( '' ); 

    const [ attempt, setAttempt ] = useState( [] );

    const [ data, setData ] = useState();

    let navigate = useNavigate();

    useEffect( () => {
        // TODO: fetch questions / answers instead
        const fetchedData = { // will be got from the API
            testType: 'back-and-forth',
            questions: [
                {
                    q: 'abrir',
                    a: 'to open',
                    id: 1,
                },
                {
                    q: 'acabar',
                    a: 'to finish',
                    id: 2,
                },
                {
                    q: 'aceitar',
                    a: 'to accept',
                    id: 3,
                },
            ],
        };

        setData( shuffleQuestions( fetchedData ) );
    }, [] );

    function doDemo() {
        return (
            <div className="demo">
                { data && data.questions.map( ( item, key ) => (
                    <div key={ key } className="demo-item">
                        { item.q } – { item.a }
                    </div>
                ) ) }
                <button onClick={ startTest }>Start</button>
            </div>
        );
    }

    function startTest() {
        setMode( 'test' );
    }

    function shuffleQuestions( data ) {
        const newData = Object.assign( {}, data );
        newData.questions = shuffle( newData.questions );
        return newData;
    }

    // from https://stackoverflow.com/questions/2450954/how-to-randomize-shuffle-a-javascript-array
    function shuffle(array) {
        let currentIndex = array.length,  randomIndex;
        
        // While there remain elements to shuffle...
        while (currentIndex != 0) {
        
            // Pick a remaining element...
            randomIndex = Math.floor(Math.random() * currentIndex);
            currentIndex--;
        
            // And swap it with the current element.
            [array[currentIndex], array[randomIndex]] = [
            array[randomIndex], array[currentIndex]];
        }
        
        return array;
    }

    function doTest() {
        const questionNumber = data.questions.length;

        const questionContent = 'q2a' === currentApproach
            ? data.questions[ currentQuestionIndex ].q
            : data.questions[ currentQuestionIndex ].a;

        return (
            <div>
                <span key="q-title">Q ( { currentQuestionIndex + 1 } / { questionNumber } ):</span>
                <span key="q-content">{ questionContent }</span><br/>
                <input key="input" type="text" value={ answer } onChange={ e => setAnswer( e.target.value ) } onKeyPress={ submitQuestion }/>
            </div>
        );
    }

    function getCurrentQuestionIndex() {
        return "QUESTION";
    }

    function submitQuestion( event ) {
        // filter non-Enter keys
        if ( event.key === 'Enter' ) {
            const currentAttempt = [ 
                ...attempt, 
                { 
                    id: data.questions[ currentQuestionIndex ].id,
                    approach: currentApproach,
                    a: answer,
                }
            ];
            
            setAttempt( currentAttempt );
    
            setAnswer( '' );
    
            // Back-and-forth approach implementation
            const questionNumber = data.questions.length;
            if ( questionNumber === currentQuestionIndex + 1 ) {
                if ( 'q2a' === currentApproach ) {
                    setCurrentQuestionIndex( 0 );
                    setCurrentApproach( 'a2q' );
                    setData( shuffleQuestions( data ) );
                    return;
                }

                // The last question was answered
                // TODO: submit the result
                navigate( `/result/${ params.testID }` );
            } else {
                setCurrentQuestionIndex( currentQuestionIndex + 1 );
            }   
        }
    }

    return (
        <>
            <h1>Test #{ params.testID }</h1>
            { 'demo' === mode && doDemo() }
            { 'test' === mode && doTest() }
        </>
    );
}