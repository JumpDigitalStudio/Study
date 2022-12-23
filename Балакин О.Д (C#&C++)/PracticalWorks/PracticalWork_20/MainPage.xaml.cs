using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Runtime.InteropServices.WindowsRuntime;
using Windows.Foundation;
using Windows.Foundation.Collections;
using Windows.UI.Xaml;
using Windows.UI.Xaml.Controls;
using Windows.UI.Xaml.Controls.Primitives;
using Windows.UI.Xaml.Data;
using Windows.UI.Xaml.Input;
using Windows.UI.Xaml.Media;
using Windows.UI.Xaml.Navigation;

// Документацию по шаблону элемента "Пустая страница" см. по адресу https://go.microsoft.com/fwlink/?LinkId=402352&clcid=0x419

namespace PracticalWork_20
{
    /// <summary>
    /// Пустая страница, которую можно использовать саму по себе или для перехода внутри фрейма.
    /// </summary>
    public sealed partial class MainPage : Page
    {
        public MainPage()
        {
            this.InitializeComponent();
        }

        private void oneButton_Click(object sender, RoutedEventArgs e)
        {
            textBox.Text += "1";
        }

        private void fourButton_Click(object sender, RoutedEventArgs e)
        {
            textBox.Text += "4";
        }

        private void sevenButton_Click(object sender, RoutedEventArgs e)
        {
            textBox.Text += "7";
        }

        private void zeroButton_Click(object sender, RoutedEventArgs e)
        {
            textBox.Text += "0";
        }

        private void twoButton_Click(object sender, RoutedEventArgs e)
        {
            textBox.Text += "2";
        }

        private void fiveButton_Click(object sender, RoutedEventArgs e)
        {
            textBox.Text += "5";
        }

        private void eightButton_Click(object sender, RoutedEventArgs e)
        {
            textBox.Text += "8";
        }

        private void threeButton_Click(object sender, RoutedEventArgs e)
        {
            textBox.Text += "3";
        }

        private void sixButton_Click(object sender, RoutedEventArgs e)
        {
            textBox.Text += "6";
        }

        private void nineButton_Click(object sender, RoutedEventArgs e)
        {
            textBox.Text += "9";
        }

        private void plusButton_Click(object sender, RoutedEventArgs e)
        {
            if (textBox.Text.Length > 0) textBox.Text += " + ";
        }

        private void minusButton_Click(object sender, RoutedEventArgs e)
        {
            if (textBox.Text.Length > 0) textBox.Text += " - ";
        }

        private void powButton_Click(object sender, RoutedEventArgs e)
        {
            if (textBox.Text.Length > 0) textBox.Text += " pow ";
        }

        private void multiplyButton_Click(object sender, RoutedEventArgs e)
        {
            if (textBox.Text.Length > 0) textBox.Text += " * ";
        }

        private void divideButton_Click(object sender, RoutedEventArgs e)
        {
            if (textBox.Text.Length > 0) textBox.Text += " / ";
        }

        private void sqrtButton_Click(object sender, RoutedEventArgs e)
        {
            if (textBox.Text.Length > 0) textBox.Text += " sqrt ";
        }

        private void eqButton_Click(object sender, RoutedEventArgs e)
        {
            String[] list = textBox.Text.Split(" ");
            try
            {
                if (list[1] == "+")
                    textBox.Text = (Int32.Parse(list[0]) + Int32.Parse(list[2])).ToString();
                if (list[1] == "-")
                    textBox.Text = (Int32.Parse(list[0]) - Int32.Parse(list[2])).ToString();
                if (list[1] == "/")
                    textBox.Text = (Int32.Parse(list[0]) / Int32.Parse(list[2])).ToString();
                if (list[1] == "*")
                    textBox.Text = (Int32.Parse(list[0]) * Int32.Parse(list[2])).ToString();
                if (list[1] == "pow")
                    textBox.Text = Math.Pow(Int32.Parse(list[0]), Int32.Parse(list[2])).ToString();
                if (list[1] == "sqrt")
                    textBox.Text = Math.Sqrt(Int32.Parse(list[0])).ToString();
            }
            catch (DivideByZeroException)
            {
                textBox.Text = "Dividie by zero not allowed!";
            }
            catch (InternalBufferOverflowException)
            {
                textBox.Text = "Buffet overflow exception!";
            }
        }

        private void ceButton_Click(object sender, RoutedEventArgs e)
        {
            textBox.Text = "";
        }
    }

}
