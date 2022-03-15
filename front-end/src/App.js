/**
 * External dependencies
 */
import {
  // Link,
  Routes,
  Route,
} from "react-router-dom";

/**
 * Internal dependencies
 */
import ChooseTopic from './pages/choose-topic';
import Test from './pages/test';
import Result from './pages/result';
import Report from './pages/report';

function App() {
  return (
    <>
    {/* <Link to="/">Test</Link> */}
    {/* <Link to="/result">Result</Link> */}
    {/* <Link to="/report">Report</Link> */}
    <Routes>      
    <Route path="/" element={ <ChooseTopic/> } />
      <Route path="/test/:testID" element={ <Test/> } />
      <Route path="/result" element={ <Result/> } />
      <Route path="/report" element={ <Report/> } />      
    </Routes>
    </>
  );
}

export default App;
