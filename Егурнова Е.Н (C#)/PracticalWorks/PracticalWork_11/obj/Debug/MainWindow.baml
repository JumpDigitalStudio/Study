   M S B A M L   `   `   `  ????K  GPracticalWork_11, Version=1.0.0.0, Culture=neutral, PublicKeyToken=null3clr-namespace:PracticalWork_11PracticalWork_11  5   	   !    PracticalWork_11.MainWindow   5   	   R NWindowsBase, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35\ XPresentationFramework, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35W SPresentationCore, Version=4.0.0.0, Culture=neutral, PublicKeyToken=31bf3856ad364e35D 9http://schemas.microsoft.com/winfx/2006/xaml/presentation    5   	   R NSystem.Xaml, Version=4.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089:x,http://schemas.microsoft.com/winfx/2006/xaml     5   	   @d2http://schemas.microsoft.com/expression/blend/2008     5   	   Jmc;http://schemas.openxmlformats.org/markup-compatibility/2006     5   	   0localclr-namespace:PracticalWork_11     5   	     ? Title$  Блокнот??5   	   $	??450??6   $	??800??6&    J? CommandBindings 5	      )  #System.Windows.Input.CommandBinding  5
   
   -   5           Command$ ApplicationCommands.Save??5
      6<   .??5      ]? .+?5   
   c? $	??Top=?6   .@?5      ?? $??ApplicationCommands.Save??6   $
??Save??68   $
??auto??6G   $??40??6U   5      ?? 5      d? 5      -   5        $??btnBold??5   @   $ ??EditingCommands.ToggleBold??6   $??B??6O   $??25??6[   $
??auto??6f   5      d? 5      -   5        $??	btnItalic??5   B   $"??EditingCommands.ToggleItalic??6   $??I??6S   $??25??6_   $
??auto??6j   5      d? 5      -   5        $??btnUnderline??5   E   $%??EditingCommands.ToggleUnderline??6   $??U??6Y   $??25??6e   $
??auto??6p   5      ?? 5      ?? 5      -   5        $??cmbFont??5      $	??150??6&   62   ?? 5      -   5        $??cmbFontSize??5      $??50??6*    ?? 
IsEditable . 6G   5      ?? 5   
   -   5        $??	rtbEditor??5      5      5      