namespace Portal.Model
{
    public class LeadItem
    {
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
        public string LeadStatus { get; set; } = "New";
        public DateTime? ExpectedCloseDate { get; set; }
        public string LeadSource { get; set; }
        public string ReviewedBy { get; set; }
        public DateTime? ReviewedDate { get; set; }
        public string ApprovedBy { get; set; }
        public DateTime? ApprovedDate { get; set; }

        public string CustomerName;
        public string ContactMobile { get; set; }
        public string ContactPerson;
        public string Email;
        public string Phone;
        public string IndustrySegment;
        public string CustomerCategory;
        public List<ProductItem> ProductNeeds = new();
        public string AdditionalNotes;
        public string Stage { get; set; }
        public string Status { get; set; }
        public LeadItem()
        {
        }
        public LeadItem(string name, string company, string stage, string status = "")
        {
            ContactMobile = name;
            CompanyName = company;
            Stage = stage;
            Status = status;
        }
    }
}
