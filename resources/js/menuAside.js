import {
  mdiAccountCircle,
  mdiMonitor,
  mdiDomain,
  mdiHandshakeOutline,
  mdiShieldCrown,
  mdiSquareEditOutline,
  mdiViewList,
  mdiTelevisionGuide,
  mdiResponsive,
  mdiPalette,
  mdiReact,
  mdiViewModule,
  mdiLockCheckOutline,
  mdiLockOutline,
  mdiAccountSupervisor,
  mdiAccount,
  mdiSchool,
  mdiTree,
  mdiLightbulbOutline,
  mdiRocket,
  mdiLightbulbOnOutline,
  mdiBook,
  mdiTheater,

} from "@mdi/js";
// import Icon from '@mdi/react';


export default [
  {
    href: "/dashboard",
    icon: mdiMonitor,
    label: "Inicio",
    to: "/dashboard",
    //role: "",
  },
  {
    href: "/profile",
    label: "Perfil",
    icon: mdiAccountCircle,
  },
  {
    label: "Seguridad",
    icon: mdiViewList,
    role: "Admin",
    permission: 'modulo.seguridad',
    menu: [
      {
        label: "Modulos",
        href: "/module",
        icon: mdiViewModule,
        permission: 'module.index',
      },
      {
        label: "Permisos",
        href: "/permissions",
        icon: mdiLockCheckOutline,
        permission: 'permissions.index',
      },
      {
        label: "Roles",
        href: "/perfiles",
        icon: mdiAccountSupervisor,
        permission: 'perfiles.index',
      },
      {
        label: "Usuarios",
        href: "/user",
        icon: mdiAccount,
        permission: 'user.index',
      },
    ],
  },
  {
    isDivider: true,
  },
];
