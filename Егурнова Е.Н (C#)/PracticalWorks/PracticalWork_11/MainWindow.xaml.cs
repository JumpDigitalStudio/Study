using Microsoft.Win32;
using System;
using System.Collections.Generic;
using System.IO;
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

namespace PracticalWork_11
{
    /// <summary>
    /// Логика взаимодействия для MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {

        Caretacker caretaker = new Caretacker();
        Originator originator = new Originator();

        public int i = 0;

        public MainWindow()
        {
            InitializeComponent();
            FontSize.SelectedIndex = 0;
            FontStyle.SelectedIndex = 0;

            ComboBoxItem ItemValue = (ComboBoxItem)FontSize.SelectedItem;
            TextBlock.FontSize = int.Parse(ItemValue.Content.ToString());

            ComboBoxItem StyleValue = (ComboBoxItem)FontStyle.SelectedItem;
            switch (StyleValue.Content.ToString())
            {
                case "Regular":
                    TextBlock.FontStyle = FontStyles.Normal;
                    break;
                case "Italic":
                    TextBlock.FontStyle = FontStyles.Italic;
                    break;
                case "Bold":
                    if (i == 0)
                    {
                        TextBlock.FontWeight = FontWeights.Bold;
                        i++;
                    }
                    else
                    {
                        TextBlock.FontWeight = FontWeights.Normal;
                        i--;
                    }
                    break;
                default:
                    TextBlock.FontStyle = FontStyles.Normal;
                    break;
            }
        }

        private void Open_Executed(object sender, ExecutedRoutedEventArgs e)
        {
            OpenFileDialog dlg = new OpenFileDialog();
            dlg.Filter = "Rich Text Format (*.rtf)|*.rtf|All files (*.*)|*.*";
            if (dlg.ShowDialog() == true)
            {
                FileStream fileStream = new FileStream(dlg.FileName, FileMode.Open);
                TextRange range = new TextRange(TextBlock.Document.ContentStart, TextBlock.Document.ContentEnd);
                range.Load(fileStream, DataFormats.Rtf);
            }
        }

        private void Save_Executed(object sender, ExecutedRoutedEventArgs e)
        {
            SaveFileDialog dlg = new SaveFileDialog();
            dlg.Filter = "Rich Text Format (*.rtf)|*.rtf|All files (*.*)|*.*";
            if (dlg.ShowDialog() == true)
            {
                FileStream fileStream = new FileStream(dlg.FileName, FileMode.Create);
                TextRange range = new TextRange(TextBlock.Document.ContentStart, TextBlock.Document.ContentEnd);
                range.Save(fileStream, DataFormats.Rtf);
            }
        }

        private void Button_Click(object sender, RoutedEventArgs e)
        {

            originator.State = caretaker.pop();
            TextRange range = new TextRange(TextBlock.Document.ContentStart, TextBlock.Document.ContentEnd);

            range.Text = originator.State.Text;
            range.ApplyPropertyValue(Inline.FontSizeProperty, originator.State.FontSize.ToString());

            if (originator.State.IsBold)
                range.ApplyPropertyValue(Inline.FontWeightProperty, FontWeights.Bold);
            else
                range.ApplyPropertyValue(Inline.FontWeightProperty, FontWeights.Normal);

            if (originator.State.IsItalics)
                range.ApplyPropertyValue(Inline.FontStyleProperty, FontStyles.Italic);
            else
                range.ApplyPropertyValue(Inline.FontStyleProperty, FontStyles.Normal);

            if (originator.State.IsUnderline)
                range.ApplyPropertyValue(Inline.TextDecorationsProperty, TextDecorations.Underline);
            else
                range.ApplyPropertyValue(Inline.TextDecorationsProperty, TextDecorations.Baseline);

        }


        private void FontSize_SelectionChanged(object sender, SelectionChangedEventArgs e)
        {
            ComboBoxItem ItemValue = (ComboBoxItem)FontSize.SelectedItem;
            TextBlock.FontSize = int.Parse(ItemValue.Content.ToString());
        }

        private void FontStyle_SelectionChanged(object sender, SelectionChangedEventArgs e)
        {

            ComboBoxItem StyleValue = (ComboBoxItem)FontStyle.SelectedItem;
            switch (StyleValue.Content.ToString())
            {
                case "Underline":
                    TextRange range = new TextRange(TextBlock.Document.ContentStart, TextBlock.Document.ContentEnd);
                    object temp = range.GetPropertyValue(Inline.TextDecorationsProperty);
                    if (temp.Equals(TextDecorations.Underline))
                        range.ApplyPropertyValue(Inline.TextDecorationsProperty, TextDecorations.Baseline);
                    else
                        range.ApplyPropertyValue(Inline.TextDecorationsProperty, TextDecorations.Underline);
                    originator.State.IsUnderline = !originator.State.IsUnderline;
                    break;
                case "Italic":
                    TextRange range1 = new TextRange(TextBlock.Document.ContentStart, TextBlock.Document.ContentEnd);
                    object temp1 = range1.GetPropertyValue(Inline.FontStyleProperty);
                    if (temp1.Equals(FontStyles.Italic))
                        range1.ApplyPropertyValue(Inline.FontStyleProperty, FontStyles.Normal);
                    if (temp1.Equals(FontStyles.Normal))
                        range1.ApplyPropertyValue(Inline.FontStyleProperty, FontStyles.Italic);
                    originator.State.IsItalics = !originator.State.IsItalics;
                    break;
                case "Bold":
                    TextRange range2 = new TextRange(TextBlock.Document.ContentStart, TextBlock.Document.ContentEnd);
                    object temp2 = range2.GetPropertyValue(FontWeightProperty);
                    if (temp2.Equals(FontWeights.Bold))
                        range2.ApplyPropertyValue(Inline.FontWeightProperty, FontWeights.Normal);

                    if (temp2.Equals(FontWeights.Normal))
                        range2.ApplyPropertyValue(Inline.FontWeightProperty, FontWeights.Bold);
                    break;
                default:
                    TextBlock.FontStyle = FontStyles.Normal;
                    break;
            }
        }
    }
}
