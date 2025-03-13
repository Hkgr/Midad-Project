import { useState } from 'react'
import './App.css'
import Welcome from './Pages/Welcome'

function App() {
  const [count, setCount] = useState(0)

  return (
   <Welcome/>
  )
}

export default App
