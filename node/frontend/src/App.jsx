import { Route, Routes } from 'react-router-dom';
import { CadastroBeneficiarios } from './components/CadastroBeneficiarios/CadastroBeneficiarios';

function App() {
  return (
    <Routes>
      <Route path='*' element={ <CadastroBeneficiarios/> } />
    </Routes>
  );
}

export default App;
