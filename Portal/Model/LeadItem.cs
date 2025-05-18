using System.ComponentModel;
using System.Text.Json.Serialization;

namespace Portal.Model
{
    public class LeadItem : INotifyPropertyChanged
    {
        public event PropertyChangedEventHandler? PropertyChanged;
        protected void OnPropertyChanged(string propertyName)
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
        }
        [JsonIgnore]
        public Action? StateHasChanged { get; set; }
        private bool _IsExistingCustomer = false;
        public bool IsExistingCustomer
        {
            get
            {
                return _IsExistingCustomer;
            }
            set
            {
                if (_IsExistingCustomer != value)
                {
                    _IsExistingCustomer = value;
                    if (_IsExistingCustomer)
                    {
                        LeadStatus = "Opportunity";
                        LeadSource = "Existing Customer";
                    }
                    else
                    {
                        LeadStatus = "New";
                    }
                    StateHasChanged?.Invoke();
                    OnPropertyChanged(nameof(IsExistingCustomer));
                }
            }
        }
        public string CompanyName { get; set; }
        public string CompanyShortName { get; set; }
        public string CompanyPhone { get; set; }
        public string CompanyEmail { get; set; }
        public string CompanyAddress { get; set; }
        public string CompanyRegion { get; set; }
        public string CompanyCity { get; set; }
        public string CompanyLatitude { get; set; }
        public string CompanyLongitude { get; set; }
        public string CompanyTaxID { get; set; }
        public string CompanyBank { get; set; }
        public string CompanyBankAccount { get; set; }
        public string IndustrySegment;
        public string CustomerCategory;

        public string LeadStatus { get; set; } = "New";
        [JsonIgnore]
        public string Stage => LeadStatus;
        [JsonIgnore]
        public string Status
        {
            get
            {
                return Stage == "Won" || Stage == "Lost" || Stage == "Done" ? "Done" :
                    DateTime.Now > ExpectedCloseDate ? "Overdue" : "";
            }
        }
        public DateTime? ExpectedCloseDate { get; set; }
        public string LeadSource { get; set; }
        public string ReviewedBy { get; set; }
        public DateTime? ReviewedDate { get; set; }
        public string ApprovedBy { get; set; }
        public DateTime? ApprovedDate { get; set; }
        public string AdditionalNotes;

        public string CustomerName;

        public string ContactName;
        public string ContactMobile { get; set; }
        public string ContactPhone { get; set; }
        public string ContactEmail { get; set; }
        public string ContactAddress { get; set; }
        public string ContactRegion { get; set; }
        public string ContactCity { get; set; }
        public string ContactLatitude { get; set; }
        public string ContactLongitude { get; set; }
        public List<ProductItem> ProductNeeds = new();
        public LeadItem()
        {
        }
        public LeadItem(string name, string company, string stage)
        {
            ContactMobile = name;
            CompanyName = company;
            LeadStatus = stage;
        }
    }
}
