using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace PracticalWork_17
{
    /// <summary>
    /// Логика взаимодействия для MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        public MainWindow()
        {
            InitializeComponent();
        }

        // При клике на кнопку Start Process
        private async void SwitchButton_Click(object sender, RoutedEventArgs e)
        {
            await taskConsiderMethod();
        }

        private async Task taskConsiderMethod()
        {
            for (int i = 0; i < 100; i++)
            {
                await Task.Delay(500);
                Bar.Value = i;
            }
        }
    }
}
