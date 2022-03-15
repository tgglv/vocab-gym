import { useState } from "react";
import { useNavigate } from "react-router-dom";

export default function ChooseTopic() {
    const [ selectedTopic, setSelectedTopic ] = useState( '-1' );

    // TODO: get topics from API
    const topics = [
        {
            name: '100 Verbs for Beginners',
            id: '100-verbs-for-beginners',
        }
    ];

    let navigate = useNavigate();

    // TODO: create a new test via API
    function chooseTopic() {
        // TODO: use the proper test ID for navigation
        navigate( '/test/123' );
    }

    return (
        <div>
            <h1>Choose a topic</h1>
            Topic: <select className="choose-topic" onChange={ setSelectedTopic }>
                <option value="-1" selected>-</option>
                { topics.map( topic => {
                    return <option value={ topic.id }>{ topic.name }</option>
                } ) }
            </select>
            <button onClick={ chooseTopic } >Choose</button>
        </div>
    );
}