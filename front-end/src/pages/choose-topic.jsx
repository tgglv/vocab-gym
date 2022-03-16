import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";

export default function ChooseTopic() {
    const [ selectedTopic, setSelectedTopic ] = useState( '-1' );
    const [ topics, setTopics ] = useState();

    let navigate = useNavigate();

    // TODO: use a base url

    // Fetch topics
    useEffect( () => {
        fetch( 'http://vocab.gym:9090/topics' )
            .then( res => res.json() )
            .then( result => { setTopics( result ) } );
    }, [] );

    // TODO: create a new test via API
    function chooseTopic() {
        if ( '-1' === selectedTopic ) {
            return;
        }
        
        // Create an attempt
        fetch( 'http://vocab.gym:9090/attempts', { 
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify( { topic: selectedTopic * 1 } )
        } )
            .then( res => res.json() )
            .then( result => {
                navigate( `/test/${ result.id }` );
            } );
    }

    return (
        <div>
            <h1>Choose a topic</h1>
            Topic: <select className="choose-topic" onChange={ e => setSelectedTopic( e.target.value ) } defaultValue="-1">
                <option value="-1">- Choose a topic -</option>
                { topics && topics.map( ( topic, key ) => {
                    return <option key={ key } value={ topic.id }>{ topic.name }</option>
                } ) }
            </select>
            <button onClick={ chooseTopic } >Choose</button>
        </div>
    );
}