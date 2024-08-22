import {
  mdiMenu,
  mdiClockOutline,
  mdiCloud,
  mdiCrop,
  mdiAccount,
  mdiCogOutline,
  mdiEmail,
  mdiLogout,
  mdiThemeLightDark,
  mdiGithub,
  mdiReact,
  mdiBell,
} from "@mdi/js";

import { usePage } from "@inertiajs/vue3";
import { colorsText } from "./colors";


export default [
  { href: "/notificaciones",
  icon: mdiBell,
  label: "Notificaciones",
  isDesktopNoLabel: true,
  isNotification: true,
  },
  {
    
    isCurrentUser: true,
    menu: [
      {
        href:"/perfil",
        icon: mdiAccount,
        label: "Mi perfil",
        to: "/profile",
        
      },
      
    
    ],
  },
  {
    icon: mdiAccount,
    isRol: true,
  },
  {
    icon: mdiLogout,
    label: "Log out",
    isDesktopNoLabel: true,
    isLogout: true,
  },
];
