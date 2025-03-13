import type { Route } from "./+types/home";
import { Welcome } from  "../Pages/welcome";
import { Link } from 'react-router-dom';

import { FaShoppingCart, FaUserAlt } from 'react-icons/fa';

export function meta({}: Route.MetaArgs) {
  return [
    { title: "New React Router App" },
    { name: "description", content: "Welcome to React Router!" },
  ];
}

export default function Home() {
  return (
      <Welcome/>
  )


}
