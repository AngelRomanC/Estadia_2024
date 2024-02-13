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
} from "@mdi/js";

export default [
  {
    // icon: mdiMenu,
    // label: "Sample menu",
    // menu: [
    //   {
    //     icon: mdiClockOutline,
    //     label: "Item One",
    //   },
    //   {
    //     icon: mdiCloud,
    //     label: "Item Two",
    //   },
    //   {
    //     isDivider: true,
    //   },
    //   {
    //     icon: mdiCrop,
    //     label: "Item Last",
    //   },
    // ],

    icon: mdiAccount,
    isRol: true,

  },
  {
    isCurrentUser: true,
    menu: [
      {
        icon: mdiAccount,
        label: "Mi perfil",
        href: "/profile",
      },
      // {
      //   icon: mdiCogOutline,
      //   label: "Settings",
      // },
      {
        icon: mdiEmail,
        label: "Notificaciones",
      },
      {
        isDivider: true,
      },
      {
        icon: mdiLogout,
        label: "Cerrar sesión",
        isLogout: true,
      },
    ],
  },
  {
    icon: mdiThemeLightDark,
    label: "Light/Dark",
    isDesktopNoLabel: true,
    isToggleLightDark: true,
  },
  // {
  //   icon: mdiGithub,
  //   label: "GitHub",
  //   isDesktopNoLabel: true,
  //   href: "https://github.com/justboil/admin-one-vue-tailwind",
  //   target: "_blank",
  // },
  // {
  //   icon: mdiReact,
  //   label: "React version",
  //   isDesktopNoLabel: true,
  //   href: "https://github.com/justboil/admin-one-react-tailwind",
  //   target: "_blank",
  // },
  {
    icon: mdiLogout,
    label: "Cerrar Sesión",
    isDesktopNoLabel: true,
    isLogout: true,
  },
];
